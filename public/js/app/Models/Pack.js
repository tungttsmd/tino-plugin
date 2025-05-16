class Pack {
  static make(data) {
    return new Pack(data);
  }
  constructor(data) {
    this._data = data;
  }
  all() {
    return this._data;
  }
}
