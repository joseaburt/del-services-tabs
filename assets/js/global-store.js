"use strict";
class DelUIGlobalStore {
    constructor() {
        this.bus = new EventBus();
        this.state = {};
    }
    getSlice(key, defaultValue) {
        if (!(key in this.state))
            return defaultValue;
        const value = this.state[key];
        if (value === null || value === undefined)
            return defaultValue;
        return value;
    }
    setSlice(key, data) {
        this.state[key] = data;
        this.bus.dispatch(key, this.state[key]);
    }
    onState(key, handler) {
        handler(this.state[key]);
        return this.bus.listen(key, handler);
    }
    static getInstance() {
        if (!this.instance)
            this.instance = new DelUIGlobalStore();
        return this.instance;
    }
    static new() {
        return new DelUIGlobalStore();
    }
}
