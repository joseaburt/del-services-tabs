"use strict";
/*
    Widget Script
    Widget Name:       Menu
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class NavbarWidget extends BaseWidget {
    constructor() {
        super();
        this.ASIDE_MENU_VISIBILITY = 'main_menu_visibility';
        this.useEffect(this.ASIDE_MENU_VISIBILITY, (value) => {
            if (value === undefined || value === null)
                return;
            if (value)
                this.openMenu();
            else
                this.closeMenu();
        });
    }
    getContainerId() {
        return 'delinternet-man-navbar-id';
    }
    stickNavbarInTop(container) {
        document.addEventListener('scroll', (ev) => {
            const isAtTop = (document.documentElement.scrollTop || document.body.scrollTop) === 0;
            container.style.top = '0px';
            container.style.position = isAtTop ? 'unset' : 'fixed';
        });
    }
    closeMenu() {
        WidgetUtils.setDisplay('main-del-menu-ul-container-xs-container-id', 'none');
    }
    openMenu() {
        WidgetUtils.setDisplay('main-del-menu-ul-container-xs-container-id', 'flex');
    }
    render(rootContainer) {
        this.stickNavbarInTop(rootContainer);
        WidgetUtils.onClick('close-menu-container-id', () => this.setState(this.ASIDE_MENU_VISIBILITY, false));
        WidgetUtils.onClick('responsive-menu-icon-button-id', () => this.setState(this.ASIDE_MENU_VISIBILITY, true));
    }
}
WidgetDOM.render(new NavbarWidget());
