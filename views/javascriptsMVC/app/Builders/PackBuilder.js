class PackBuilder {
  static make() {
    return new PackBuilder();
  }
  constructor(dataPack = {}) {
    this._builder = { ...dataPack }; //shallow copy
  }
  set(key, value) {
    this._builder[key] = value;
    return this;
  }
  build() {
    return Pack.make(this._builder).all();
  }
}
