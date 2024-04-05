"use strict";
/*
    Widget Script
    Widget Name:       Delinternet Services Packs Tabs....
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
const ON_TAB_CLICKED_EVENT = "ON_TAB_CLICKED_EVENT";
class TabContentSectionComponent {
    constructor(section, bus) {
        this.bus = bus;
        this.section = section;
        this.dataId = this.getDataId();
        this.element = document.getElementById(`${TabContentSectionComponent.TAB_CONTENT_ID_PREFIX}-${this.dataId}`);
        this.bus.listen(ON_TAB_CLICKED_EVENT, (dataId) => {
            if (dataId === this.dataId)
                this.show();
            else
                this.hide();
        });
    }
    show() {
        if (this.element)
            this.element.style.display = "block";
    }
    hide() {
        if (this.element)
            this.element.style.display = "none";
    }
    getDataId() {
        var _a;
        return (_a = this.section.getAttribute(TabContentSectionComponent.TAB_CONTENT_DATA_ID_KEY)) !== null && _a !== void 0 ? _a : "00";
    }
}
TabContentSectionComponent.TAB_CONTENT_DATA_ID_KEY = "data-tab-content-id";
TabContentSectionComponent.TAB_CONTENT_ID_PREFIX = "service-tab-content";
class TabButtonComponent {
    constructor(button, bus) {
        this.bus = bus;
        this.button = button;
        this.dataId = this.getDataId();
        this.button.addEventListener("click", () => {
            this.select();
            this.bus.dispatch(ON_TAB_CLICKED_EVENT, this.dataId);
        });
        this.bus.listen(ON_TAB_CLICKED_EVENT, (dataId) => {
            if (dataId !== this.dataId)
                this.unSelect();
        });
    }
    select() {
        this.button.classList.add(TabButtonComponent.ACTIVE_CLASS);
    }
    unSelect() {
        this.button.classList.remove(TabButtonComponent.ACTIVE_CLASS);
    }
    getDataId() {
        var _a;
        return (_a = this.button.getAttribute(TabButtonComponent.TAB_DATA_ID_KEY)) !== null && _a !== void 0 ? _a : "00";
    }
    click() {
        this.button.click();
    }
}
TabButtonComponent.ACTIVE_CLASS = "active-tab";
TabButtonComponent.TAB_DATA_ID_KEY = "data-tab-id";
class ServiceTabsWidget {
    constructor() {
        this.tabs = {};
        this.contentSections = {};
        this.bus = new EventBus();
        const tabSectionsContainer = document.getElementById(ServiceTabsWidget.TAB_CONTENT_SECTIONS_CONTAINER);
        if (!tabSectionsContainer)
            throw new Error("Tab Section Container is not defined.");
        tabSectionsContainer.querySelectorAll("section").forEach((section) => {
            const tabSection = new TabContentSectionComponent(section, this.bus);
            this.contentSections[tabSection.getDataId()] = tabSection;
        });
        const tabContainer = document.getElementById(ServiceTabsWidget.TABS_CONTAINER);
        if (!tabContainer)
            throw new Error("Tab Container is not defined.");
        tabContainer.querySelectorAll(ServiceTabsWidget.BUTTON_TAB_CLASS).forEach((tab, index) => {
            const tabButton = new TabButtonComponent(tab, this.bus);
            this.tabs[tabButton.getDataId()] = tabButton;
            if (index === 0)
                tabButton.click();
        });
    }
    static getInstance() {
        if (!this.instance)
            this.instance = new ServiceTabsWidget();
        return this.instance;
    }
}
ServiceTabsWidget.BUTTON_TAB_CLASS = ".tab-btn";
ServiceTabsWidget.TABS_CONTAINER = "del-service-tabs-container-id";
ServiceTabsWidget.TAB_CONTENT_SECTIONS_CONTAINER = "del-service-content-sections-container-id";
window.addEventListener("load", () => ServiceTabsWidget.getInstance());
