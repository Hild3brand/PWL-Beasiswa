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
      programStudi.belongsTo(models.Fakultas, {
          foreignKey: 'fakultas_id',
          as: 'fakultas'
      });
      programStudi.hasMany(models.User, {
          foreignKey: 'program_studi_id',
          as: 'users'
      });
    }
  }
  programStudi.init({
    kode: DataTypes.STRING,
    nama: DataTypes.STRING,
    fakultas_id: DataTypes.INTEGER,
  }, {
    sequelize,
    modelName: 'programStudi',
    tableName: 'program_studis',
  });
  return programStudi;
};