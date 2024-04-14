/* 
    Widget Script
    Widget Name:       Delinternet Reviews
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/

class ReviewsWidget extends BaseWidget {
    public getContainerId(): string {
        return "del-reviews-widget-root";
    }

    public render(): void {
        const cardContainer = WidgetUtils.getDivById("reviews-cards");
        const headerContainerScroll = WidgetUtils.useScrollAnimationFrame(cardContainer);

        const firstReviewCard = document.querySelector('.review-card:first-child') as HTMLDivElement;
        const lastReviewCard = document.querySelector('.review-card:last-child') as HTMLDivElement;

        WidgetUtils.getButtonById("prev-review-button").addEventListener("click", () => headerContainerScroll.goToLeft());
        WidgetUtils.getButtonById("next-review-button").addEventListener("click", () => headerContainerScroll.goToRight());

        WidgetUtils.fromButton(WidgetUtils.getButtonById("prev-review-button")).disableItIfGivenElementIsVisible(firstReviewCard)
        WidgetUtils.fromButton(WidgetUtils.getButtonById("next-review-button")).disableItIfGivenElementIsVisible(lastReviewCard)
    }
}

WidgetDOM.render(new ReviewsWidget());
