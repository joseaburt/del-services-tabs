"use strict";
/*
    Widget Script
    Widget Name:       Delinternet Reviews
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class ReviewsWidget {
    render() {
        const cardContainer = WidgetUtils.getDivById("reviews-cards");
        cardContainer.scrollLeft = 0;
    }
}
WidgetDOM.render(new ReviewsWidget());
