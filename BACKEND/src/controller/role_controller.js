const { Fakultas, programStudi, User, Role } = require('../models');
const schema = require('../validation');
const Validator = require('fastest-validator');
const v = new Validator;
const bcrypt = require('bcrypt'); // Import bcrypt

module.exports = {
    index: async (req, res, next) => {
        try {
            const users = await Role.findAll();

            return res.status(200).json({
                status: 'OK',
                message: 'Get All User Success',
                data: users
            });
        } catch (err) {
            next(err);
        }
    },
    create: async (req, res, next) => {
        try {
            const { nama_role } = req.body;
            
            const body = req.body;
            const validate = v.validate(body, schema.role.create);
            console.log(validate);
    
            if (validate.length) {
                return res.status(400).json(validate);
            }
    
            const created = await Role.create({
                nama_role,
            });
    
            return res.status(201).json({
                status: 'CREATED',
                message: 'New Role Created',
                data: created
            });
        } catch (err) {
            next(err);
        }
    },

    update: async (req, res, next) => {
        try {
            const { id } = req.params;
            let { nama_role } = req.body;

            const body = req.body;
            const validate = v.validate(body, schema.role.update);

            if (validate.length) {
                return res.status(400).json(validate);
            }

            const role = await Role.findOne({ where: { id: id } });
            if (!role) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Role Didn't Exist`,
                    data: null
                })
            }

            if (!nama_role) nama_role = role.nama_role;

            const updated = await Role.update({
                nama_role,
            }, {
                where: {
                    id: id
                }
            })

            return res.status(200).json({
                status: 'OK',
                message: 'Update Role Success',
                data: updated
            })
        } catch (err) {
            next(err);
        }
    },

    delete: async (req, res, next) => {
        try {
            const { id } = req.params;

            const role = await Role.findOne({
                where: {
                    id: id
                }
            });

            if (!role) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Role Didn't Exist`,
                    data: null
                });
            }

            const deleted = await Role.destroy({
                where: {
                    id: id
                }
            });

            return res.status(200).json({
                status: 'OK',
                message: 'Delete Role Success',
                data: deleted
            });
        } catch (err) {
            next(err);
        }
    },
    getById: async (req, res, next) => {
        try {
            const { id } = req.params;

            const role = await Role.findOne({
                where: { id },
            });

            if (!role) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Role with id ${id} not found`,
                    data: null
                });
            }

            return res.status(200).json({
                status: 'OK',
                message: 'Get Role by id Success',
                data: role
            });
        } catch (err) {
            next(err);
        }
    },
}