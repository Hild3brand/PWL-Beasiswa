const bcrypt = require('bcrypt');
const { User } = require('../models');
const schema = require('../validation')
const Validator = require('fastest-validator')
const v = new Validator;

module.exports = {
    register: async (req, res, next) => {
        try {
            const { name, email, password } = req.body;

            const exist = await User.findOne({ where: { email: email } });

            if (exist) {
                return res.status(400).json({
                    status: 'BAD_REQUEST',
                    message: 'User Already Exist',
                    data: null
                });
            }

            const body = req.body;
            const validate = v.validate(body, schema.auth.register) //password min:8

            if (validate.length) {
                return res.status(400).json(validate)
            }

            const hashedPass = await bcrypt.hash(password, 10);

            const newUser = await User.create({
                name,
                email,
                password: hashedPass,
            });

            return res.status(201).json({
                status: 'CREATED',
                message: 'User Registered',
                data: newUser
            });
        } catch (err) {
            next(err);
        }
    },

    login: async (req, res, next) => {
        try {
            const user = await User.authenticate(req.body);
            const accessToken = user.generateToken();

            return res.status(200).json({
                status: 'OK',
                message: 'Login Success',
                data: {
                    id: user.id,
                    nama: user.nama,
                    email: user.email,
                    token: accessToken
                }
            });
        } catch (err) {
            next(err);
        }
    },
}