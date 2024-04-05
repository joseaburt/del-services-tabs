
/* 
    Widget Script
    Widget Name:       FooterWidget
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/


class  FooterWidget extends BaseWidget {
    public getContainerId(): string {
        return "del-footer-widget";
    }

    public render(): void {}
}


WidgetDOM.render(new FooterWidget());
    