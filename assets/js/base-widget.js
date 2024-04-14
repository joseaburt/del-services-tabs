"use strict";
/*
    Widget Script
    Widget Name:       Base Widget
    Author:            Jose Aburto
    Author URI:        https://www.linkedin.com/in/jose-aburto/
*/
class BaseWidget {
  constructor() {
    this.store = DelUIGlobalStore.getInstance();
  }
  useEffect(key, callback) {
    return this.store.onState(key, callback);
  }
  setState(key, data) {
    return this.store.setSlice(key, data);
  }
}
class WidgetDOM {
  static render(widget) {
    document.addEventListener("DOMContentLoaded", () => {
      const rootContainer = WidgetUtils.getDivById(widget.getContainerId());
      if (!rootContainer) return;
      widget.render(rootContainer);
    });
  }
}
