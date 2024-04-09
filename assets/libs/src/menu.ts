/* 
    Widget Script
    Widget Name:       Menu
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/




class NavbarWidget extends BaseWidget {
    public getContainerId(): string {
        return "delinternet-man-navbar-id";
    }

    private stickNavbarInTop(container: HTMLDivElement) {
        document.addEventListener("scroll", (ev) => {
            const isAtTop = (document.documentElement.scrollTop || document.body.scrollTop) === 0;
            container.style.top = "0px"
            container.style.position = isAtTop ? "unset" : "fixed"
        });
    }

    public render(rootContainer: HTMLDivElement): void {
        this.stickNavbarInTop(rootContainer);

        WidgetUtils.getButtonById("responsive-menu-icon-button-id").addEventListener("click", () => {
            WidgetUtils.getDivById("main-del-menu-ul-container-xs-container-id").style.display = "block";
        });

        WidgetUtils.getDivById("close-menu-container-id").addEventListener("click", () => {
            WidgetUtils.getDivById("main-del-menu-ul-container-xs-container-id").style.display = "none";
        });

    }
}


WidgetDOM.render(new NavbarWidget());