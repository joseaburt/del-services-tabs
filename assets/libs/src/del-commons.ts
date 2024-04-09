type UnSubscribe = () => void;


/* 
    Widget Script
    Widget Name:       Enent Bus for communications
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class EventBus {
    private bus: Record<string, Function[]> = {};

    constructor() {
        this.off = this.off.bind(this);
        this.dispatch = this.dispatch.bind(this);
        this.listen = this.listen.bind(this);
        this.once = this.once.bind(this);
        this.getAllListenersFromEvent = this.getAllListenersFromEvent.bind(this);
    }

    public off(event: string, handler: Function): void {
        const index = this.bus[event]?.indexOf(handler) ?? -1;
        this.bus[event]?.splice(index >>> 0, 1);
    }

    public listen(event: string, handler: Function): UnSubscribe {
        if (typeof handler !== "function") throw new Error("InvalidEventHandlerType");
        if (this.bus[event] === undefined) this.bus[event] = [];
        this.bus[event].push(handler);
        return () => this.off(event, handler);
    }

    public dispatch(event: string, payload?: unknown): void {
        const handlers = this.getAllListenersFromEvent(event);
        for (const handler of handlers) handler(payload);
    }

    public once(event: string, handler: Function): void {
        const handlerOnce = (payload: unknown) => {
            handler(payload);
            this.off(event, handlerOnce);
        };
        this.listen(event, handlerOnce);
    }

    public getAllListenersFromEvent(event: string): Function[] {
        if (this.bus[event] === undefined) return [];
        return this.bus[event];
    }
}


/* 
    Widget Script
    Widget Name:       Global Store
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class DelUIGlobalStore {
    private bus: EventBus = new EventBus();
    private state: Record<string, any> = {};

    private constructor() { }

    public getSlice<T = any>(key: string, defaultValue: T): T {
        if (!(key in this.state)) return defaultValue;
        const value = this.state[key];
        if (value === null || value === undefined) return defaultValue;
        return value;
    }


    public setSlice(key: string, data: any) {
        this.state[key] = data;
        this.bus.dispatch(key, this.state[key]);
        return data;
    }

    public onState<T = any>(key: string, handler: (value: T | undefined) => void): UnSubscribe {
        handler(this.state[key]);
        return this.bus.listen(key, handler);
    }

    private static instance: DelUIGlobalStore | undefined;

    public static getInstance(): DelUIGlobalStore {
        if (!this.instance) this.instance = new DelUIGlobalStore();
        return this.instance;
    }

    public static new(): DelUIGlobalStore {
        return new DelUIGlobalStore();
    }
}

/* 
    Widget Script
    Widget Name:       Base Utils
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class WidgetUtils {
    public static isElementVisible(element: Element, cb: (isVisible: boolean) => void): void {
        const options = { root: document.documentElement };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => cb(entry.intersectionRatio > 0));
        }, options);
        observer.observe(element);
    }

    public static useIndicator(indicatorElement: HTMLElement) {
        return {
            show: function () {
                indicatorElement.style.display = "block";
            },
            setPosition: function (followingElement: HTMLElement, container: HTMLElement, animation = true) {
                if (!followingElement) return;
                const buttonRect = followingElement.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();
                const buttonPosition = buttonRect.left - containerRect.left;
                indicatorElement.style.transition = animation ? "left 0.5s ease" : "";
                indicatorElement.style.left = `${buttonPosition}px`;
                indicatorElement.style.width = `${followingElement.offsetWidth}px`;
            },
        };
    }

    public static useScrollAnimationFrame(container: HTMLDivElement, onScroll?: () => void) {
        function easeInOutQuad(t: number, b: number, c: number, d: number) {
            t /= d / 2;
            if (t < 1) return (c / 2) * t * t + b;
            t--;
            return (-c / 2) * (t * (t - 2) - 1) + b;
        }

        return {
            perform: function (start: number, end: number) {
                const duration = 1000;
                const startTime = performance.now();
                function updateScroll(timestamp: any) {
                    const elapsed = timestamp - startTime;
                    let progress = Math.min(elapsed / duration, 1);
                    container.scrollLeft = easeInOutQuad(progress, start, end, 1);
                    if (progress < 1) requestAnimationFrame(updateScroll);
                    if (typeof onScroll === 'function') onScroll();
                }
                requestAnimationFrame(updateScroll);
            },
            goToRight: function () {
                const startScroll = container.scrollLeft;
                let targetScroll = container.scrollLeft + container.offsetWidth / 2;
                this.perform(startScroll, targetScroll - startScroll);
            },
            goToLeft: function () {
                const startScroll = container.scrollLeft;
                let targetScroll = container.scrollLeft - container.offsetWidth / 2;
                this.perform(startScroll, targetScroll - startScroll);
            },
        };
    }


    public static getButtonById(id: string): HTMLButtonElement {
        return document.getElementById(id) as HTMLButtonElement
    }

    public static queryButtonSelector(selector: string): HTMLButtonElement {
        return document.querySelector(selector) as HTMLButtonElement
    }

    public static getDivById(id: string): HTMLDivElement {
        return document.getElementById(id) as HTMLDivElement
    }

    public static getAttribute(el: HTMLElement, key: string, defaultValue: string = ""): string {
        return el.getAttribute(key) ?? defaultValue;
    }

    public static show(el: HTMLElement, displayValue?: "block" | "flex") {
        el.style.display = displayValue ?? "block";
    }

    public static hide(el: HTMLElement, displayValue?: "block" | "flex") {
        el.style.display = "none";
    }


    public static fromButton(element: HTMLButtonElement) {
        return {
            hiddenItIf(condition = false) {
                element.style.display = "none"
                element.style.cursor = condition ? "not-allowed" : "pointer";
            },
            disableItIfGivenElementIsVisible: (givenElement: HTMLElement) => {
                this.isElementVisible(givenElement, (isVisible) => {
                    element.disabled = isVisible
                    element.style.opacity = isVisible ? "0.5" : "1";
                    element.style.cursor = isVisible ? "not-allowed" : "pointer";
                });
            },
        };
    }

    public static createButton() {
        return document.createElement("button");
    }


    public static onClick(id: string, handler: (ev: MouseEvent) => void) {
        WidgetUtils.getButtonById(id).addEventListener('click', handler);
    }


    public static setDisplay(id: string, type: 'flex' | 'block' | 'grid' | 'inline-block' | 'none') {
        WidgetUtils.getDivById(id).style.display = type;
    }

}

/* 
    Widget Script
    Widget Name:       Base Widget
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
abstract class BaseWidget {
    private store: DelUIGlobalStore = DelUIGlobalStore.getInstance();
    
    public abstract getContainerId(): string;
    public abstract render(rootContainer: HTMLDivElement): void;

    protected useEffect<T = any>(key: string, callback: (value: T | undefined) => void): UnSubscribe {
        return this.store.onState(key, callback);
    }

    protected setState(key: string, data: any) {
        return this.store.setSlice(key, data);
    }
}


class WidgetDOM {
    public static render(widget: BaseWidget): void {
        document.addEventListener("DOMContentLoaded", () => {
            const rootContainer = WidgetUtils.getDivById(widget.getContainerId());
            if (!rootContainer) return;
            widget.render(rootContainer);
        });
    }
}