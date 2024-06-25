'use strict';
const { Model } = require('sequelize');
module.exports = (sequelize, DataTypes) => {
  class Periode extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
    }
  }
  Periode.init({
    semester: DataTypes.STRING,
    start_date: DataTypes.DATE,
    end_date: DataTypes.DATE,
  }, {
    sequelize,
    modelName: 'Periode',
    tableName: 'periodes',
  });
  return Periode;
};