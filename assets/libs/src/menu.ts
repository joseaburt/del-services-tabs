/* 
    Widget Script
    Widget Name:       Menu
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/

class NavbarWidget extends BaseWidget {
    private readonly ASIDE_MENU_VISIBILITY: string = 'main_menu_visibility';

    constructor() {
        super();

        this.useEffect<boolean>(this.ASIDE_MENU_VISIBILITY, (value) => {
            if (value === undefined || value === null) return;
            if (value) this.openMenu();
            else this.closeMenu();
        });
    }

    public getContainerId(): string {
        return 'delinternet-man-navbar-id';
    }

    private stickNavbarInTop(container: HTMLDivElement) {
        document.addEventListener('scroll', (ev) => {
            const isAtTop = (document.documentElement.scrollTop || document.body.scrollTop) === 0;
            container.style.top = '0px';
            container.style.position = isAtTop ? 'unset' : 'fixed';
        });
    }

    protected closeMenu() {
        WidgetUtils.setDisplay('main-del-menu-ul-container-xs-container-id', 'none');
    }

    protected openMenu() {
        WidgetUtils.setDisplay('main-del-menu-ul-container-xs-container-id', 'flex');
    }

    private initModal() {
        let isOpen = false;
        const openButtons = document.querySelectorAll('#shall-we-call-you-text-button');
        const closeButton = WidgetUtils.getButtonById('close-model-button');

        const modalContainer = WidgetUtils.getDivById('global-model-container');

        openButtons.forEach((el) => {
            el.addEventListener('click', () => {
                console.log('Open button click');

                modalContainer.style.display = 'block';
                isOpen = true;
                document.body.style.overflow = 'hidden';
            });
        });

        closeButton.addEventListener('click', () => {
            console.log('Close button click');

            modalContainer.style.display = 'none';
            isOpen = false;
            document.body.style.overflow = 'auto';
        });
    }

    public render(rootContainer: HTMLDivElement): void {
        this.initModal();
        this.stickNavbarInTop(rootContainer);
        WidgetUtils.onClick('close-menu-container-id', () => this.setState(this.ASIDE_MENU_VISIBILITY, false));
        WidgetUtils.onClick('responsive-menu-icon-button-id', () => this.setState(this.ASIDE_MENU_VISIBILITY, true));
    }
}

WidgetDOM.render(new NavbarWidget());
