const { Fakultas, programStudi, User, Role } = require('../models');
const schema = require('../validation');
const Validator = require('fastest-validator');
const v = new Validator;
const bcrypt = require('bcrypt'); // Import bcrypt

module.exports = {
    index: async (req, res, next) => {
        try {
            const users = await User.findAll({
                include: [
                    {
                        model: programStudi,
                        include: {
                            model: Fakultas,
                            as: 'fakultas' // specify the alias here
                        },
                        as: 'programStudi' // specify the alias for programStudi if needed
                    },
                    {
                        model: Role, // include the Role model
                        as: 'role' // specify the alias for Role if needed
                    }
                ]
            });

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
            const { nrp, nama, email, password, status, role_id, program_studi_id } = req.body;
            
            const body = req.body;
            const validate = v.validate(body, schema.user.create);
            console.log(validate);
    
            if (validate.length) {
                return res.status(400).json(validate);
            }
    
            const user = await User.findOne({ where: { nrp } });
    
            if (user) {
                return res.status(409).json({
                    status: 'CONFLICT',
                    message: 'Data Already Exist',
                    data: null
                });
            }
    
            const hashedPassword = await bcrypt.hash(password, 10);
    
            const created = await User.create({
                nrp, 
                nama, 
                email, 
                password: hashedPassword, 
                status, 
                role_id: Number(role_id), // Convert role_id to number
                program_studi_id: Number(program_studi_id) // Convert program_studi_id to number
            });
    
            return res.status(201).json({
                status: 'CREATED',
                message: 'New User Created',
                data: created
            });
        } catch (err) {
            next(err);
        }
    },

    update: async (req, res, next) => {
        try {
            const { nrp } = req.params;
            let { nama, email, password, status, role_id, program_studi_id } = req.body;

            const body = req.body;
            const validate = v.validate(body, schema.user.update);

            if (validate.length) {
                return res.status(400).json(validate);
            }

            const user = await User.findOne({ where: { nrp: nrp } });
            if (!user) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `User Didn't Exist`,
                    data: null
                })
            }

            if (!email) email = user.email;
            if (!password) password = user.password;
            if (!status) status = user.status;
            if (!role_id) role_id = user.role_id;
            if (!program_studi_id) program_studi_id = user.program_studi_id;

            if (password !== user.password) {
                // Hash the new password if it has been updated
                password = await bcrypt.hash(password, 10);
            }

            const updated = await User.update({
                nama, 
                email, 
                password, 
                status, 
                role_id, 
                program_studi_id
            }, {
                where: {
                    nrp: nrp
                }
            })

            return res.status(200).json({
                status: 'OK',
                message: 'Update User Success',
                data: updated
            })
        } catch (err) {
            next(err);
        }
    },

    delete: async (req, res, next) => {
        try {
            const { nrp } = req.params;

            const user = await User.findOne({
                where: {
                    nrp: nrp
                }
            });

            if (!user) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `User Didn't Exist`,
                    data: null
                });
            }

            const deleted = await User.destroy({
                where: {
                    nrp: nrp
                }
            });

            return res.status(200).json({
                status: 'OK',
                message: 'Delete User Success',
                data: deleted
            });
        } catch (err) {
            next(err);
        }
    },

    getByNrp: async (req, res, next) => {
        try {
            const { nrp } = req.params;

            const user = await User.findOne({
                where: { nrp },
                include: {
                    model: programStudi,
                    include: {
                        model: Fakultas,
                        as: 'fakultas'
                    },
                    as: 'programStudi'
                }
            });

            if (!user) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `User with NRP ${nrp} not found`,
                    data: null
                });
            }

            return res.status(200).json({
                status: 'OK',
                message: 'Get User by NRP Success',
                data: user
            });
        } catch (err) {
            next(err);
        }
    },
}