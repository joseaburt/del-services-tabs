/* 
    Widget Script
    Widget Name:       Base Widget
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/


abstract class BaseWidget {
    public abstract render(): void;
    public abstract getContainerId(): string;
}


class WidgetDOM {
    public static render(widget: BaseWidget): void {
        document.addEventListener("DOMContentLoaded", () => {
            const rootContainer = WidgetUtils.getDivById(widget.getContainerId());
            if (!rootContainer) return;
            widget.render();
        });
    }
}