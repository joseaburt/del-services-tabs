/* 
    Widget Script
    Widget Name:       Tab Component
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/

function respondToVisibility(element, callback) {
    const options = { root: document.documentElement };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => callback(entry.intersectionRatio > 0));
    }, options);
    observer.observe(element);
}

function fromButton(element) {
    return {
        hiddenItIf(condition = false) {
            element.style.display = "none"
            element.style.cursor = condition ? "not-allowed" : "pointer";
        },
        disableItIfGivenElementIsVisible: function (givenElement) {
            respondToVisibility(givenElement, (isVisible) => {
                element.style.disabled = !isVisible;
                element.style.opacity = isVisible ? 0.5 : 1;
                element.style.cursor = isVisible ? "not-allowed" : "pointer";
            });
        },
    };
}

function initControllers({ firstTabButton, lastTabButton, headerContainer, sumOfAllButtonWidth, onScroll }) {
    const prevButton = document.getElementById("pre-tabs-btn");
    const nextButton = document.getElementById("next-tabs-btn");

    function easeInOutQuad(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return (c / 2) * t * t + b;
        t--;
        return (-c / 2) * (t * (t - 2) - 1) + b;
    }

    fromButton(nextButton).disableItIfGivenElementIsVisible(lastTabButton);

    nextButton.addEventListener("click", () => {
        const duration = 1000;
        const startTime = performance.now();
        const startScroll = headerContainer.scrollLeft;
        let targetScroll = headerContainer.scrollLeft + headerContainer.offsetWidth / 2;
        const aux = headerContainer.scrollLeft - lastTabButton.offsetWidth - 100;
        if (aux > sumOfAllButtonWidth) targetScroll = headerContainer.scrollLeft + headerContainer.offsetWidth;

        function updateScroll(timestamp) {
            const elapsed = timestamp - startTime;
            let progress = Math.min(elapsed / duration, 1);
            headerContainer.scrollLeft = easeInOutQuad(progress, startScroll, targetScroll - startScroll, 1);
            if (progress < 1) requestAnimationFrame(updateScroll);
            onScroll();
        }

        requestAnimationFrame(updateScroll);
    });

    fromButton(prevButton).disableItIfGivenElementIsVisible(firstTabButton);

    prevButton.addEventListener("click", () => {
        const duration = 1000;
        const startTime = performance.now();
        const startScroll = headerContainer.scrollLeft;
        let targetScroll = headerContainer.scrollLeft - headerContainer.offsetWidth / 2;
        const aux = headerContainer.scrollLeft - lastTabButton.offsetWidth - 100;
        if (aux < sumOfAllButtonWidth) targetScroll = headerContainer.scrollLeft - headerContainer.offsetWidth;

        function updateScroll(timestamp) {
            const elapsed = timestamp - startTime;
            let progress = Math.min(elapsed / duration, 1);
            headerContainer.scrollLeft = easeInOutQuad(progress, startScroll, targetScroll - startScroll, 1);
            if (progress < 1) requestAnimationFrame(updateScroll);
            onScroll();
        }

        requestAnimationFrame(updateScroll);
    });

    return { prevButton, nextButton }
}

function useIndicator() {
    const indicator = document.getElementById("tabs-indicator");
    return {
        show: function () {
            indicator.style.display = "block";
        },
        setPosition: function (element, container, animation = true) {
            if (!element) return;
            const buttonRect = element.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();
            const buttonPosition = buttonRect.left - containerRect.left;
            indicator.style.transition = animation ? "left 0.5s ease" : "";
            indicator.style.left = `${buttonPosition}px`;
            indicator.style.width = `${element.offsetWidth}px`;
        },
    };
}

function useTabContent() {
    const container = document.getElementById("questions-tab-container");
    const contents = container.querySelectorAll(".questions-tab-tab-content");
    const selectedTabId = container.getAttribute("data-selectedTabId") ?? "0";

    return {
        init: function () {
            contents.forEach((section) => {
                const id = section.getAttribute("data-id");
                if (id === selectedTabId) section.style.display = "block";
                else section.style.display = "none";

                section
                    .querySelector("#tabs-accordion-container")
                    .querySelectorAll("li")
                    .forEach((item) => {
                        const detailsContainer = item.getElementsByClassName("tabs-accordion-details")[0];
                        const toggleBtn = item.getElementsByTagName("button")[0];

                        const toggleBtnOpenIcon = toggleBtn.querySelector("#open-btn-icon");
                        const toggleBtnCloseIcon = toggleBtn.querySelector("#close-btn-icon");

                        toggleBtnOpenIcon.style.display = "block";
                        toggleBtnCloseIcon.style.display = "none";

                        toggleBtn.addEventListener("click", (ev) => {
                            const isSummaryVisible = item.getAttribute("data-isSummaryVisible") === "true" ? true : false;
                            if (!isSummaryVisible) {
                                detailsContainer.style.display = "block";
                                toggleBtnOpenIcon.style.display = "none";
                                toggleBtnCloseIcon.style.display = "block";
                            } else {
                                detailsContainer.style.display = "none";
                                toggleBtnOpenIcon.style.display = "block";
                                toggleBtnCloseIcon.style.display = "none";
                            }

                            item.setAttribute("data-isSummaryVisible", !isSummaryVisible);
                        });
                    });
            });
        },
        show: function (index) {
            contents.forEach((el) => (el.style.display = "none"));
            const contentContainer = document.getElementById(`tab-content-${index + 1}`);
            if (contentContainer) contentContainer.style.display = "block";
        },
    };
}

function main() {
    const indicator = useIndicator();
    const contentTab = useTabContent();
    const headerContainer = document.getElementById("questions-tab-header");
    const items = headerContainer.querySelectorAll("li.questions-tab-item");
    let [lastTabButton, firstTabButton, selectedItem, sumOfAllButtonWidth] = [null, null, null, 0];

    items.forEach((item, i) => {
        const button = item.getElementsByTagName("button")[0];
        sumOfAllButtonWidth += button.offsetWidth;

        if (i === 0) {
            selectedItem = firstTabButton = button;
            indicator.setPosition(item, headerContainer);
        }

        indicator.show();

        button.addEventListener("click", (ev) => {
            contentTab.show(i);
            indicator.setPosition(item, headerContainer);
            selectedItem = ev.target;
        });

        lastTabButton = item;
    });

    const { prevButton, nextButton } = initControllers({
        firstTabButton,
        lastTabButton,
        headerContainer,
        sumOfAllButtonWidth,
        onScroll: () => indicator.setPosition(selectedItem, headerContainer, false),
    });

    const container = document.getElementsByClassName("tabs-container2")[0];
    fromButton(prevButton).hiddenItIf(headerContainer.offsetWidth < container.offsetWidth)
    fromButton(nextButton).hiddenItIf(headerContainer.offsetWidth < container.offsetWidth)

    contentTab.init();
}

document.addEventListener("DOMContentLoaded", () => {
    main();
});
