"use strict";
/*
    Widget Script
    Widget Name:       Accordion
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class AccordionWidget extends BaseWidget {
    getContainerId() {
        return "accordion-container";
    }
    render() {
        const container = document.getElementById('accordion-container');
        if (!container)
            return;
        container.querySelectorAll("li").forEach((item) => {
            const detailsContainer = item.getElementsByClassName("accordion-details")[0];
            item.getElementsByTagName("button")[0].addEventListener("click", () => {
                const isSummaryVisible = item.getAttribute('data-isSummaryVisible') === 'true' ? true : false;
                if (!isSummaryVisible)
                    detailsContainer.style.display = 'block';
                else
                    detailsContainer.style.display = 'none';
                item.setAttribute('data-isSummaryVisible', isSummaryVisible ? "false" : "true");
            });
        });
    }
}
WidgetDOM.render(new AccordionWidget());
