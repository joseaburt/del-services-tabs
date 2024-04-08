"use strict";
/*
    Widget Script
    Widget Name:       Menu
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class NavbarWidget extends BaseWidget {
    getContainerId() {
        return "delinternet-man-navbar-id";
    }
    render() {
        WidgetUtils.getButtonById("responsive-menu-icon-button-id").addEventListener("click", () => {
            document.body.style.overflow = "hidden"
            WidgetUtils.getDivById("main-del-menu-ul-container-xs-container-id").style.display = "flex";
        });
        WidgetUtils.getDivById("close-menu-container-id").addEventListener("click", () => {
            document.body.style.overflow = "unset"
            WidgetUtils.getDivById("main-del-menu-ul-container-xs-container-id").style.display = "none";
        });
    }
}
WidgetDOM.render(new NavbarWidget());
