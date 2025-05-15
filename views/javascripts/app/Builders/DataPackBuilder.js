class DataPackBuilder {
    constructor(dataPack = {}) {
      this._builder = { ...dataPack }; //shallow copy
    }
    static make() {
      return new DataPackBuilder();
    }
    set(key, value) {
      this._builder[key] = value;
      return this;
    }
    build() {
      return DataPack.make(this._builder).all();
    }
  }