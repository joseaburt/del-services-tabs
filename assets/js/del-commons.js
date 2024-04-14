"use strict";
/*
    Widget Script
    Widget Name:       Enent Bus for communications
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class EventBus {
  constructor() {
    this.bus = {};
    this.off = this.off.bind(this);
    this.dispatch = this.dispatch.bind(this);
    this.listen = this.listen.bind(this);
    this.once = this.once.bind(this);
    this.getAllListenersFromEvent = this.getAllListenersFromEvent.bind(this);
  }
  off(event, handler) {
    var _a, _b, _c;
    const index =
      (_b =
        (_a = this.bus[event]) === null || _a === void 0
          ? void 0
          : _a.indexOf(handler)) !== null && _b !== void 0
        ? _b
        : -1;
    (_c = this.bus[event]) === null || _c === void 0
      ? void 0
      : _c.splice(index >>> 0, 1);
  }
  listen(event, handler) {
    if (typeof handler !== "function")
      throw new Error("InvalidEventHandlerType");
    if (this.bus[event] === undefined) this.bus[event] = [];
    this.bus[event].push(handler);
    return () => this.off(event, handler);
  }
  dispatch(event, payload) {
    const handlers = this.getAllListenersFromEvent(event);
    for (const handler of handlers) handler(payload);
  }
  once(event, handler) {
    const handlerOnce = (payload) => {
      handler(payload);
      this.off(event, handlerOnce);
    };
    this.listen(event, handlerOnce);
  }
  getAllListenersFromEvent(event) {
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
  constructor() {
    this.bus = new EventBus();
    this.state = {};
  }
  getSlice(key, defaultValue) {
    if (!(key in this.state)) return defaultValue;
    const value = this.state[key];
    if (value === null || value === undefined) return defaultValue;
    return value;
  }
  setSlice(key, data) {
    this.state[key] = data;
    this.bus.dispatch(key, this.state[key]);
    return data;
  }
  onState(key, handler) {
    handler(this.state[key]);
    return this.bus.listen(key, handler);
  }
  static getInstance() {
    if (!this.instance) this.instance = new DelUIGlobalStore();
    return this.instance;
  }
  static new() {
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
  static useScrollAnimationFrame(container, onScroll) {
    function easeInOutQuad(t, b, c, d) {
      t /= d / 2;
      if (t < 1) return (c / 2) * t * t + b;
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
          if (progress < 1) requestAnimationFrame(updateScroll);
          if (typeof onScroll === "function") onScroll();
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
    return (_a = el.getAttribute(key)) !== null && _a !== void 0
      ? _a
      : defaultValue;
  }
  static show(el, displayValue) {
    el.style.display =
      displayValue !== null && displayValue !== void 0 ? displayValue : "block";
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
  static onClick(id, handler) {
    WidgetUtils.getButtonById(id).addEventListener("click", handler);
  }
  static setDisplay(id, type) {
    WidgetUtils.getDivById(id).style.display = type;
  }
}
/*
    Widget Script
    Widget Name:       Base Widget
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class BaseWidget {
  constructor() {
    this.store = DelUIGlobalStore.getInstance();
  }
  useEffect(key, callback) {
    return this.store.onState(key, callback);
  }
  setState(key, data) {
    return this.store.setSlice(key, data);
  }
}
class WidgetDOM {
  static render(widget) {
    document.addEventListener("DOMContentLoaded", () => {
      const rootContainer = WidgetUtils.getDivById(widget.getContainerId());
      if (!rootContainer) return;
      widget.render(rootContainer);
    });
  }
}
