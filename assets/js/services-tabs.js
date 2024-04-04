"use strict";
/*
    Widget Script
    Widget Name:       Delinternet Services Packs Tabs
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
var EventBus = /** @class */ (function () {
    function EventBus() {
        this.bus = {};
        this.off = this.off.bind(this);
        this.dispatch = this.dispatch.bind(this);
        this.listen = this.listen.bind(this);
        this.once = this.once.bind(this);
        this.getAllListenersFromEvent = this.getAllListenersFromEvent.bind(this);
    }
    EventBus.prototype.off = function (event, handler) {
        var _a, _b, _c;
        var index = (_b = (_a = this.bus[event]) === null || _a === void 0 ? void 0 : _a.indexOf(handler)) !== null && _b !== void 0 ? _b : -1;
        (_c = this.bus[event]) === null || _c === void 0 ? void 0 : _c.splice(index >>> 0, 1);
    };
    EventBus.prototype.listen = function (event, handler) {
        var _this = this;
        if (typeof handler !== "function")
            throw new Error("InvalidEventHandlerType");
        if (this.bus[event] === undefined)
            this.bus[event] = [];
        this.bus[event].push(handler);
        return function () { return _this.off(event, handler); };
    };
    EventBus.prototype.dispatch = function (event, payload) {
        var handlers = this.getAllListenersFromEvent(event);
        for (var _i = 0, handlers_1 = handlers; _i < handlers_1.length; _i++) {
            var handler = handlers_1[_i];
            handler(payload);
        }
    };
    EventBus.prototype.once = function (event, handler) {
        var _this = this;
        var handlerOnce = function (payload) {
            handler(payload);
            _this.off(event, handlerOnce);
        };
        this.listen(event, handlerOnce);
    };
    EventBus.prototype.getAllListenersFromEvent = function (event) {
        if (this.bus[event] === undefined)
            return [];
        return this.bus[event];
    };
    return EventBus;
}());
var ON_TAB_CLICKED_EVENT = "ON_TAB_CLICKED_EVENT";
var TabContentSectionComponent = /** @class */ (function () {
    function TabContentSectionComponent(section, bus) {
        var _this = this;
        this.bus = bus;
        this.section = section;
        this.dataId = this.getDataId();
        this.element = document.getElementById("".concat(TabContentSectionComponent.TAB_CONTENT_ID_PREFIX, "-").concat(this.dataId));
        this.bus.listen(ON_TAB_CLICKED_EVENT, function (dataId) {
            if (dataId === _this.dataId)
                _this.show();
            else
                _this.hide();
        });
    }
    TabContentSectionComponent.prototype.show = function () {
        if (this.element)
            this.element.style.display = "block";
    };
    TabContentSectionComponent.prototype.hide = function () {
        if (this.element)
            this.element.style.display = "none";
    };
    TabContentSectionComponent.prototype.getDataId = function () {
        var _a;
        return (_a = this.section.getAttribute(TabContentSectionComponent.TAB_CONTENT_DATA_ID_KEY)) !== null && _a !== void 0 ? _a : "00";
    };
    TabContentSectionComponent.TAB_CONTENT_DATA_ID_KEY = "data-tab-content-id";
    TabContentSectionComponent.TAB_CONTENT_ID_PREFIX = "service-tab-content";
    return TabContentSectionComponent;
}());
var TabButtonComponent = /** @class */ (function () {
    function TabButtonComponent(button, bus) {
        var _this = this;
        this.bus = bus;
        this.button = button;
        this.dataId = this.getDataId();
        this.button.addEventListener("click", function () {
            _this.select();
            _this.bus.dispatch(ON_TAB_CLICKED_EVENT, _this.dataId);
        });
        this.bus.listen(ON_TAB_CLICKED_EVENT, function (dataId) {
            if (dataId !== _this.dataId)
                _this.unSelect();
        });
    }
    TabButtonComponent.prototype.select = function () {
        this.button.classList.add(TabButtonComponent.ACTIVE_CLASS);
    };
    TabButtonComponent.prototype.unSelect = function () {
        this.button.classList.remove(TabButtonComponent.ACTIVE_CLASS);
    };
    TabButtonComponent.prototype.getDataId = function () {
        var _a;
        return (_a = this.button.getAttribute(TabButtonComponent.TAB_DATA_ID_KEY)) !== null && _a !== void 0 ? _a : "00";
    };
    TabButtonComponent.prototype.click = function () {
        this.button.click();
    };
    TabButtonComponent.ACTIVE_CLASS = "active-tab";
    TabButtonComponent.TAB_DATA_ID_KEY = "data-tab-id";
    return TabButtonComponent;
}());
var ServiceTabsWidget = /** @class */ (function () {
    function ServiceTabsWidget() {
        var _this = this;
        this.tabs = {};
        this.contentSections = {};
        this.bus = new EventBus();
        var tabSectionsContainer = document.getElementById(ServiceTabsWidget.TAB_CONTENT_SECTIONS_CONTAINER);
        if (!tabSectionsContainer)
            throw new Error("Tab Section Container is not defined.");
        tabSectionsContainer.querySelectorAll("section").forEach(function (section) {
            var tabSection = new TabContentSectionComponent(section, _this.bus);
            _this.contentSections[tabSection.getDataId()] = tabSection;
        });
        var tabContainer = document.getElementById(ServiceTabsWidget.TABS_CONTAINER);
        if (!tabContainer)
            throw new Error("Tab Container is not defined.");
        tabContainer.querySelectorAll(ServiceTabsWidget.BUTTON_TAB_CLASS).forEach(function (tab, index) {
            var tabButton = new TabButtonComponent(tab, _this.bus);
            _this.tabs[tabButton.getDataId()] = tabButton;
            if (index === 0)
                tabButton.click();
        });
    }
    ServiceTabsWidget.getInstance = function () {
        if (!this.instance)
            this.instance = new ServiceTabsWidget();
        return this.instance;
    };
    ServiceTabsWidget.BUTTON_TAB_CLASS = ".tab-btn";
    ServiceTabsWidget.TABS_CONTAINER = "del-service-tabs-container-id";
    ServiceTabsWidget.TAB_CONTENT_SECTIONS_CONTAINER = "del-service-content-sections-container-id";
    return ServiceTabsWidget;
}());
window.addEventListener("load", function () { return ServiceTabsWidget.getInstance(); });
