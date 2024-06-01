'use strict';
const {
  Model
} = require('sequelize');
module.exports = (sequelize, DataTypes) => {
  class programStudi extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      programStudi.hasMany(models.Fakultas, {foreignKey: 'fakultas_id', as: 'fakultas'});
    }
  }
  programStudi.init({
    id: DataTypes.INTEGER,
    kode: DataTypes.STRING,
    nama: DataTypes.STRING,
    fakultas_id: DataTypes.INT,
  }, {
    sequelize,
    modelName: 'programStudi',
  });
  return programStudi;
};