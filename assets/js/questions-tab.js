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

function enabledButton(element) {
    return {
        ifGivenElementIsVisible: function (givenElement) {
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

    enabledButton(nextButton).ifGivenElementIsVisible(lastTabButton);

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

    enabledButton(prevButton).ifGivenElementIsVisible(firstTabButton);

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
    const contents = container.querySelectorAll(".questions-tab-tab-content")
    const selectedTabId = container.getAttribute("data-selectedTabId") ?? "0";

    return {
        init: function () {
            contents.forEach((section) => {
                const id = section.getAttribute("data-id");
                if (id === selectedTabId) section.style.display = "block";
                else section.style.display = "none";
            });
        },
        show: function (index) {
            contents.forEach((el) => (el.style.display = "none"));
            const contentContainer = document.getElementById(`tab-content-${index + 1}`);
            if (contentContainer) contentContainer.style.display = "block";
        }
    }
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

    initControllers({
        firstTabButton,
        lastTabButton,
        headerContainer,
        sumOfAllButtonWidth,
        onScroll: () => indicator.setPosition(selectedItem, headerContainer, false),
    });

    contentTab.init();
}

document.addEventListener("DOMContentLoaded", () => main());
