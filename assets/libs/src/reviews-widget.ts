/* 
    Widget Script
    Widget Name:       Delinternet Reviews
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/



class ReviewsWidget implements BaseWidget {
    public render(): void {
        const cardContainer = WidgetUtils.getDivById("reviews-cards");

        cardContainer.scrollLeft = 0;
    }
}


WidgetDOM.render(new ReviewsWidget());