'use strict';
const {Model,Op} = require('sequelize');

const JWT_SECRET_KEY = process.env.JWT_SECRET_KEY;
const JWT_EXPIRED_TIME= process.env.JWT_EXPIRED_TIME;
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const program_studi = require('./program_studi');

module.exports = (sequelize, DataTypes) => {
  class Beasiswa extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
        Beasiswa.belongsTo(models.Periode, { foreignKey: 'periode_id', as: 'periode' });
      }
  }
  Beasiswa.init({
    jenis: DataTypes.STRING,
    nama: DataTypes.STRING,
    periode_id: DataTypes.INTEGER,
  }, {
    sequelize,
    modelName: 'Beasiswa',
    tableName: 'beasiswas',
  });
  return Beasiswa;
};