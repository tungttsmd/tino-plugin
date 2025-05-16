class ButtonController {
  static make() {
    return new ButtonController();
  }
  constructor() {
    this.buttonBinder = ButtonBinder.make();
  }
  bindEvents() {
    this.buttonBinder.run();
  }
}
