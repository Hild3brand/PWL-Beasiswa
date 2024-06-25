'use strict';
const {Model,Op} = require('sequelize');

const JWT_SECRET_KEY = process.env.JWT_SECRET_KEY;
const JWT_EXPIRED_TIME= process.env.JWT_EXPIRED_TIME;
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const program_studi = require('./program_studi');

module.exports = (sequelize, DataTypes) => {
  class User extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      // Define association here
      User.belongsTo(models.programStudi, { foreignKey: 'program_studi_id', as: 'programStudi' });
      User.belongsTo(models.Role, { foreignKey: 'role_id', as: 'role' }); // Define association with Role
    }

    async checkPassword(password) {
      return await bcrypt.compareSync(password, this.password);
    }

    generateToken() {
      const payload = {
        nrp: this.nrp,
        nama: this.nama,
        email: this.email,
        password: this.password,
        status : this.status,
        role_id: this.role_id,
        program_studi_id: this.program_studi_id,
      };
      console.log(JWT_EXPIRED_TIME);
      return jwt.sign(payload, JWT_SECRET_KEY, { expiresIn: JWT_EXPIRED_TIME });
    }

    static authenticate = async ({email, password}) => {
      console.log(await this.findOne({where: {email: email}}));
      try {
        const user = await this.findOne({
          where: {
            [Op.or]: [
              { email: email },
              { nrp: email }
            ]
          }
        });
        if(!user) return Promise.reject(new Error('User Not Found'));
        console.log(await user.checkPassword(password));

        const valid = await user.checkPassword(password);
        if(!valid) return Promise.reject(new Error('Wrong Password'));

        return Promise.resolve(user);
      } catch (err) {
        return Promise.reject(err);
      }
    };
  }
  User.init({
    nrp: DataTypes.STRING,
    nama: DataTypes.STRING,
    email: DataTypes.STRING,
    password: DataTypes.STRING,
    status: DataTypes.STRING,
    role_id: DataTypes.INTEGER,
    program_studi_id: DataTypes.INTEGER,
  }, {
    sequelize,
    modelName: 'User',
  });
  return User;
};