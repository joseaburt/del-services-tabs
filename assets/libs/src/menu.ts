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

    public render(): void {
        WidgetUtils.getButtonById("responsive-menu-icon-button-id").addEventListener("click", () => {
            WidgetUtils.getDivById("main-del-menu-ul-container-xs-container-id").style.display = "block";
        });

        WidgetUtils.getDivById("close-menu-container-id").addEventListener("click", () => {
            WidgetUtils.getDivById("main-del-menu-ul-container-xs-container-id").style.display = "none";
        });

    }
}


WidgetDOM.render(new NavbarWidget());