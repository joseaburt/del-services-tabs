/* 
    Widget Script
    Widget Name:       Base Widget
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/


interface BaseWidget {
    render(): void;
}


class WidgetDOM {
    public static render(widget: BaseWidget): void {
        document.addEventListener("DOMContentLoaded", () => {
            widget.render();
        });
    }
}