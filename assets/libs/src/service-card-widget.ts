
/* 
    Widget Script
    Widget Name:       ServiceCardWidget
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/


class  ServiceCardWidget extends BaseWidget {
    public getContainerId(): string {
        return "del-service-card-widget";
    }

    public render(): void {}
}


WidgetDOM.render(new ServiceCardWidget());
    