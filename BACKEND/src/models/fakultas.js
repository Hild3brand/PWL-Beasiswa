'use strict';
const { Model } = require('sequelize');
module.exports = (sequelize, DataTypes) => {
  class Fakultas extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      Fakultas.hasMany(models.programStudi, {foreignKey: 'fakultas_id', as: 'Fakultas'});
    }
  }
  Fakultas.init({
    kode: DataTypes.STRING,
    nama: DataTypes.STRING
  }, {
    sequelize,
    modelName: 'Fakultas',
    tableName: 'fakultass',
  });
  return Fakultas;
};