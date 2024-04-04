/* 
    Widget Script
    Widget Name:       Delinternet Services Packs Tabs
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/

type DataId = string;
type UnSubscribe = () => void;

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

const ON_TAB_CLICKED_EVENT = "ON_TAB_CLICKED_EVENT";

class TabContentSectionComponent {
    private static readonly TAB_CONTENT_DATA_ID_KEY = "data-tab-content-id";
    private static readonly TAB_CONTENT_ID_PREFIX = "service-tab-content";

    private bus: EventBus;
    private dataId: DataId;
    private section: HTMLDivElement;
    private element: HTMLDivElement | null;

    constructor(section: HTMLDivElement, bus: EventBus) {
        this.bus = bus;
        this.section = section;
        this.dataId = this.getDataId();
        this.element = document.getElementById(`${TabContentSectionComponent.TAB_CONTENT_ID_PREFIX}-${this.dataId}`) as HTMLDivElement;

        this.bus.listen(ON_TAB_CLICKED_EVENT, (dataId: DataId) => {
            if (dataId === this.dataId) this.show();
            else this.hide();
        });
    }

    private show(): void {
        if (this.element) this.element.style.display = "block";
    }

    private hide(): void {
        if (this.element) this.element.style.display = "none";
    }

    public getDataId(): DataId {
        return this.section.getAttribute(TabContentSectionComponent.TAB_CONTENT_DATA_ID_KEY) ?? "00";
    }
}

class TabButtonComponent {
    private static readonly ACTIVE_CLASS = "active-tab";
    private static readonly TAB_DATA_ID_KEY = "data-tab-id";

    private bus: EventBus;
    private dataId: DataId;
    private button: HTMLButtonElement;

    constructor(button: HTMLButtonElement, bus: EventBus) {
        this.bus = bus;
        this.button = button;
        this.dataId = this.getDataId();
        this.button.addEventListener("click", () => {
            this.select();
            this.bus.dispatch(ON_TAB_CLICKED_EVENT, this.dataId);
        });
        this.bus.listen(ON_TAB_CLICKED_EVENT, (dataId: DataId) => {
            if (dataId !== this.dataId) this.unSelect();
        });
    }

    private select() {
        this.button.classList.add(TabButtonComponent.ACTIVE_CLASS);
    }

    private unSelect() {
        this.button.classList.remove(TabButtonComponent.ACTIVE_CLASS);
    }

    public getDataId(): DataId {
        return this.button.getAttribute(TabButtonComponent.TAB_DATA_ID_KEY) ?? "00";
    }

    public click() {
        this.button.click();
    }
}

class ServiceTabsWidget {
    private static readonly BUTTON_TAB_CLASS = ".tab-btn";
    private static readonly TABS_CONTAINER = "del-service-tabs-container-id";
    private static readonly TAB_CONTENT_SECTIONS_CONTAINER = "del-service-content-sections-container-id";

    private bus: EventBus;
    private tabs: Record<DataId, TabButtonComponent> = {};
    public static instance: ServiceTabsWidget | undefined;
    private contentSections: Record<DataId, TabContentSectionComponent> = {};

    private constructor() {
        this.bus = new EventBus();

        const tabSectionsContainer = document.getElementById(ServiceTabsWidget.TAB_CONTENT_SECTIONS_CONTAINER);
        if (!tabSectionsContainer) throw new Error("Tab Section Container is not defined.");
        tabSectionsContainer.querySelectorAll<HTMLDivElement>("section").forEach((section) => {
            const tabSection = new TabContentSectionComponent(section, this.bus);
            this.contentSections[tabSection.getDataId()] = tabSection;
        });

        const tabContainer = document.getElementById(ServiceTabsWidget.TABS_CONTAINER);
        if (!tabContainer) throw new Error("Tab Container is not defined.");
        tabContainer.querySelectorAll<HTMLButtonElement>(ServiceTabsWidget.BUTTON_TAB_CLASS).forEach((tab, index) => {
            const tabButton = new TabButtonComponent(tab, this.bus);
            this.tabs[tabButton.getDataId()] = tabButton;
            if (index === 0) tabButton.click();
        });
    }

    public static getInstance() {
        if (!this.instance) this.instance = new ServiceTabsWidget();
        return this.instance;
    }
}

window.addEventListener("load", () => ServiceTabsWidget.getInstance());
