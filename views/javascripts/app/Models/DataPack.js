class DataPack {
    constructor(data) {
      this._data = data;
    }
    all() {
      return this._data;
    }
    static make(data) {
      return new DataPack(data);
    }
  }