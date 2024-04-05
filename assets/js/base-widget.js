"use strict";
/*
    Widget Script
    Widget Name:       Base Widget
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class WidgetDOM {
    static render(widget) {
        document.addEventListener("DOMContentLoaded", () => {
            widget.render();
        });
    }
}
