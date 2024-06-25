const { Fakultas } = require('../models');
const fakultas = require('../models/fakultas');
const schema = require('../validation');
const Validator = require('fastest-validator');
const v = new Validator;

module.exports = {
    index: async (req, res, next) => {
        try {
            const fakultas = await Fakultas.findAll();

            return res.status(200).json({
                status: 'OK',
                message: 'Get All Fakultas Success',
                data: fakultas
            });
        } catch (err) {
            next(err);
        }
    },

    create: async (req, res, next) => {
        try {
            const { kode, nama } = req.body;
            
            const body = req.body;
            const validate = v.validate(body, schema.fakultas.create);
            console.log(validate);
    
            if (validate.length) {
                return res.status(400).json(validate);
            }
    
            const fakultas = await Fakultas.findOne({ where: { kode } });
    
            if (fakultas) {
                return res.status(409).json({
                    status: 'CONFLICT',
                    message: 'Data Already Exist',
                    data: null
                });
            }
    
            const created = await Fakultas.create({
                kode, 
                nama,
            });
    
            return res.status(201).json({
                status: 'CREATED',
                message: 'New Fakultas Created',
                data: created
            });
        } catch (err) {
            next(err);
        }
    },

    update: async (req, res, next) => {
        try {
            const { kode } = req.params;
            let { nama } = req.body;

            const body = req.body;
            const validate = v.validate(body, schema.fakultas.update);

            if (validate.length) {
                return res.status(400).json(validate);
            }

            const fakultas = await Fakultas.findOne({ where: { kode: kode } });
            if (!fakultas) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `fakultas Didn't Exist`,
                    data: null
                })
            }

            if (!nama) nama = fakultas.nama;

            const updated = await Fakultas.update({
                nama,
            }, {
                where: {
                    kode: kode
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
            const { kode } = req.params;

            const fakultas = await Fakultas.findOne({
                where: {
                    kode: kode
                }
            });

            if (!fakultas) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Fakultas Didn't Exist`,
                    data: null
                });
            }

            const deleted = await Fakultas.destroy({
                where: {
                    kode: kode
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

    getByKode: async (req, res, next) => {
        try {
            const { kode } = req.params;

            const fakultas = await Fakultas.findOne({
                where: { kode },
            });

            if (!fakultas) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Fakultas with kode ${kode} not found`,
                    data: null
                });
            }

            return res.status(200).json({
                status: 'OK',
                message: 'Get Fakultas by Kode Success',
                data: fakultas
            });
        } catch (err) {
            next(err);
        }
    },
}