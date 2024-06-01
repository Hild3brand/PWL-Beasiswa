'use strict';
const {
  Model
} = require('sequelize');
module.exports = (sequelize, DataTypes) => {
  class User extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      User.hasMany(models.programStudi, {foreignKey: 'program_studi_id', as: 'program_studi'});
      User.hasMany(models.Role, {foreignKey: 'role_id', as: 'role'});
    }
  }
  User.init({
    id: DataTypes.INTEGER,
    nrp: DataTypes.STRING,
    nama: DataTypes.STRING,
    email: DataTypes.STRING,
    password: DataTypes.STRING,
    status: DataTypes.STRING,
    role_id: DataTypes.INT,
    program_studi_id: DataTypes.INT,
  }, {
    sequelize,
    modelName: 'User',
  });
  return User;
};