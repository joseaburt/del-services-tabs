"use strict";
/*
    Widget Script
    Widget Name:       Question Tabs
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class QuestionsTabWidget extends BaseWidget {
    getContainerId() {
        return 'questions-tab-container';
    }
    useTabContent() {
        const container = WidgetUtils.getDivById('questions-tab-container');
        const selectedTabId = WidgetUtils.getAttribute(container, 'data-selectedTabId', '0');
        const contents = container.querySelectorAll('.questions-tab-tab-content');
        return {
            init: function () {
                contents.forEach((section) => {
                    const id = WidgetUtils.getAttribute(section, 'data-id', '0');
                    if (id === selectedTabId)
                        WidgetUtils.show(section);
                    else
                        WidgetUtils.hide(section);
                    const tabAccordionContainer = section.querySelector('#tabs-accordion-container');
                    if (!tabAccordionContainer)
                        throw Error('#tabs-accordion-container element not found.');
                    tabAccordionContainer.querySelectorAll('li').forEach((item) => {
                        const toggleBtn = item.getElementsByTagName('button')[0];
                        const toggleBtnOpenIcon = toggleBtn.querySelector('#open-btn-icon');
                        const toggleBtnCloseIcon = toggleBtn.querySelector('#close-btn-icon');
                        const detailsContainer = item.getElementsByClassName('tabs-accordion-details')[0];
                        WidgetUtils.show(toggleBtnOpenIcon);
                        WidgetUtils.hide(toggleBtnCloseIcon);
                        toggleBtn.addEventListener('click', () => {
                            const isSummaryVisible = WidgetUtils.getAttribute(item, 'data-isSummaryVisible') === 'true' ? true : false;
                            if (!isSummaryVisible) {
                                WidgetUtils.show(detailsContainer);
                                WidgetUtils.show(toggleBtnCloseIcon);
                                WidgetUtils.hide(toggleBtnOpenIcon);
                            }
                            else {
                                WidgetUtils.hide(detailsContainer);
                                WidgetUtils.show(toggleBtnOpenIcon);
                                WidgetUtils.hide(toggleBtnCloseIcon);
                            }
                            item.setAttribute('data-isSummaryVisible', isSummaryVisible ? 'false' : 'true');
                        });
                    });
                });
            },
            show: function (index) {
                contents.forEach((el) => WidgetUtils.hide(el));
                const contentContainer = document.getElementById(`tab-content-${index + 1}`);
                if (contentContainer)
                    WidgetUtils.show(contentContainer);
            },
        };
    }
    initControllers(props) {
        const { firstTabButton, lastTabButton, headerContainer, sumOfAllButtonWidth, onScroll } = props;
        const prevButton = WidgetUtils.getButtonById('pre-tabs-btn');
        const nextButton = WidgetUtils.getButtonById('next-tabs-btn');
        const headerContainerScroll = WidgetUtils.useScrollAnimationFrame(headerContainer, onScroll);
        WidgetUtils.fromButton(nextButton).disableItIfGivenElementIsVisible(lastTabButton);
        WidgetUtils.fromButton(prevButton).disableItIfGivenElementIsVisible(firstTabButton);
        nextButton.addEventListener('click', () => {
            const startScroll = headerContainer.scrollLeft;
            let targetScroll = headerContainer.scrollLeft + headerContainer.offsetWidth / 2;
            const aux = headerContainer.scrollLeft - lastTabButton.offsetWidth - 100;
            if (aux > sumOfAllButtonWidth)
                targetScroll = headerContainer.scrollLeft + headerContainer.offsetWidth;
            headerContainerScroll.perform(startScroll, targetScroll - startScroll);
        });
        prevButton.addEventListener('click', () => {
            const startScroll = headerContainer.scrollLeft;
            let targetScroll = headerContainer.scrollLeft - headerContainer.offsetWidth / 2;
            const aux = headerContainer.scrollLeft - lastTabButton.offsetWidth - 100;
            if (aux < sumOfAllButtonWidth)
                targetScroll = headerContainer.scrollLeft - headerContainer.offsetWidth;
            headerContainerScroll.perform(startScroll, targetScroll - startScroll);
        });
        return { prevButton, nextButton };
    }
    render() {
        const contentTab = this.useTabContent();
        const headerContainer = WidgetUtils.getDivById('questions-tab-header');
        const indicator = WidgetUtils.useIndicator(WidgetUtils.getDivById('tabs-indicator'));
        const items = headerContainer.querySelectorAll('li.questions-tab-item');
        let sumOfAllButtonWidth = 0;
        let selectedItem;
        let lastTabButton = WidgetUtils.createButton();
        let firstTabButton = WidgetUtils.createButton();
        items.forEach((item, i) => {
            const button = item.getElementsByTagName('button')[0];
            sumOfAllButtonWidth += button.offsetWidth;
            if (i === 0) {
                selectedItem = firstTabButton = button;
                indicator.setPosition(item, headerContainer);
            }
            indicator.show();
            button.addEventListener('click', (ev) => {
                contentTab.show(i);
                indicator.setPosition(item, headerContainer);
                selectedItem = ev.target;
            });
            lastTabButton = button;
        });
        const { prevButton, nextButton } = this.initControllers({
            firstTabButton,
            lastTabButton,
            headerContainer,
            sumOfAllButtonWidth,
            onScroll: () => indicator.setPosition(selectedItem, headerContainer, false),
        });
        const container = document.getElementsByClassName('tabs-container2')[0];
        // WidgetUtils.fromButton(prevButton).hiddenItIf(headerContainer.offsetWidth < container.offsetWidth)
        // WidgetUtils.fromButton(nextButton).hiddenItIf(headerContainer.offsetWidth < container.offsetWidth)
        contentTab.init();
    }
}
WidgetDOM.render(new QuestionsTabWidget());
