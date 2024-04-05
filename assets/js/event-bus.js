"use strict";
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
        const index = (_b = (_a = this.bus[event]) === null || _a === void 0 ? void 0 : _a.indexOf(handler)) !== null && _b !== void 0 ? _b : -1;
        (_c = this.bus[event]) === null || _c === void 0 ? void 0 : _c.splice(index >>> 0, 1);
    }
    listen(event, handler) {
        if (typeof handler !== "function")
            throw new Error("InvalidEventHandlerType");
        if (this.bus[event] === undefined)
            this.bus[event] = [];
        this.bus[event].push(handler);
        return () => this.off(event, handler);
    }
    dispatch(event, payload) {
        const handlers = this.getAllListenersFromEvent(event);
        for (const handler of handlers)
            handler(payload);
    }
    once(event, handler) {
        const handlerOnce = (payload) => {
            handler(payload);
            this.off(event, handlerOnce);
        };
        this.listen(event, handlerOnce);
    }
    getAllListenersFromEvent(event) {
        if (this.bus[event] === undefined)
            return [];
        return this.bus[event];
    }
}
