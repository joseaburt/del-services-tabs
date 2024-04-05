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

}

