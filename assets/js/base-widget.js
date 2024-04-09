"use strict";
/*
    Widget Script
    Widget Name:       Base Widget
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class BaseWidget {
}
class WidgetDOM {
    static render(widget) {
        document.addEventListener("DOMContentLoaded", () => {
            const rootContainer = WidgetUtils.getDivById(widget.getContainerId());
            if (!rootContainer)
                return;
            widget.render(rootContainer);
        });
    }
}
