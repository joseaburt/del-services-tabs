"use strict";
class WidgetUtils {
    static isElementVisible(element, cb) {
        const options = { root: document.documentElement };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => cb(entry.intersectionRatio > 0));
        }, options);
        observer.observe(element);
    }
    static useIndicator(indicatorElement) {
        return {
            show: function () {
                indicatorElement.style.display = "block";
            },
            setPosition: function (followingElement, container, animation = true) {
                if (!followingElement)
                    return;
                const buttonRect = followingElement.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();
                const buttonPosition = buttonRect.left - containerRect.left;
                indicatorElement.style.transition = animation ? "left 0.5s ease" : "";
                indicatorElement.style.left = `${buttonPosition}px`;
                indicatorElement.style.width = `${followingElement.offsetWidth}px`;
            },
        };
    }
    static useScrollAnimationFrame(container, onScroll) {
        function easeInOutQuad(t, b, c, d) {
            t /= d / 2;
            if (t < 1)
                return (c / 2) * t * t + b;
            t--;
            return (-c / 2) * (t * (t - 2) - 1) + b;
        }
        return {
            perform: function (start, end) {
                const duration = 1000;
                const startTime = performance.now();
                function updateScroll(timestamp) {
                    const elapsed = timestamp - startTime;
                    let progress = Math.min(elapsed / duration, 1);
                    container.scrollLeft = easeInOutQuad(progress, start, end, 1);
                    if (progress < 1)
                        requestAnimationFrame(updateScroll);
                    if (typeof onScroll === 'function')
                        onScroll();
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
    static getButtonById(id) {
        return document.getElementById(id);
    }
    static queryButtonSelector(selector) {
        return document.querySelector(selector);
    }
    static getDivById(id) {
        return document.getElementById(id);
    }
    static getAttribute(el, key, defaultValue = "") {
        var _a;
        return (_a = el.getAttribute(key)) !== null && _a !== void 0 ? _a : defaultValue;
    }
    static show(el, displayValue) {
        el.style.display = displayValue !== null && displayValue !== void 0 ? displayValue : "block";
    }
    static hide(el, displayValue) {
        el.style.display = "none";
    }
    static fromButton(element) {
        return {
            hiddenItIf(condition = false) {
                element.style.display = "none";
                element.style.cursor = condition ? "not-allowed" : "pointer";
            },
            disableItIfGivenElementIsVisible: (givenElement) => {
                this.isElementVisible(givenElement, (isVisible) => {
                    element.disabled = isVisible;
                    element.style.opacity = isVisible ? "0.5" : "1";
                    element.style.cursor = isVisible ? "not-allowed" : "pointer";
                });
            },
        };
    }
    static createButton() {
        return document.createElement("button");
    }
}
