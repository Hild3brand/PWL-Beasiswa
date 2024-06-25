const { Beasiswa, Periode } = require('../models');
const schema = require('../validation');
const Validator = require('fastest-validator');
const v = new Validator;

module.exports = {
    index: async (req, res, next) => {
        try {
            const beasiswa = await Beasiswa.findAll(
                {
                    include: [
                        {
                            model: Periode,
                            as: 'periode' // specify the alias for programStudi if needed
                        }
                    ]
                }
            );

            return res.status(200).json({
                status: 'OK',
                message: 'Get All Beasiswa Success',
                data: beasiswa
            });
        } catch (err) {
            next(err);
        }
    },

    create: async (req, res, next) => {
        try {
            const { jenis, nama, periode_id } = req.body;
            
            const body = req.body;
            const validate = v.validate(body, schema.beasiswa.create);
            console.log(validate);
    
            if (validate.length) {
                return res.status(400).json(validate);
            }
    
            const created = await Beasiswa.create({
                jenis, 
                nama,
                periode_id
            });
    
            return res.status(201).json({
                status: 'CREATED',
                message: 'New Beasiswa Created',
                data: created
            });
        } catch (err) {
            next(err);
        }
    },

    update: async (req, res, next) => {
        try {
            const { id } = req.params;
            let { jenis,nama,periode_id } = req.body;

            const body = req.body;
            const validate = v.validate(body, schema.beasiswa.update);

            if (validate.length) {
                return res.status(400).json(validate);
            }

            const beasiswa = await Beasiswa.findOne({ where: { id: id } });
            if (!beasiswa) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `beasiswa Didn't Exist`,
                    data: null
                })
            }

            if (!nama) nama = beasiswa.nama;

            const updated = await Beasiswa.update({
                jenis,
                nama,
                periode_id
            }, {
                where: {
                    id: id
                }
            })

            return res.status(200).json({
                status: 'OK',
                message: 'Update Beasiswa Success',
                data: updated
            })
        } catch (err) {
            next(err);
        }
    },

    delete: async (req, res, next) => {
        try {
            const { id } = req.params;

            const beasiswa = await Beasiswa.findOne({
                where: {
                    id: id
                }
            });

            if (!beasiswa) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Beasiswa Didn't Exist`,
                    data: null
                });
            }

            const deleted = await Beasiswa.destroy({
                where: {
                    id: id
                }
            });

            return res.status(200).json({
                status: 'OK',
                message: 'Delete Beasiswa Success',
                data: deleted
            });
        } catch (err) {
            next(err);
        }
    },

    getById: async (req, res, next) => {
        try {
            const { id } = req.params;

            const beasiswa = await Beasiswa.findOne({
                where: { id },
            });

            if (!beasiswa) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Beasiswa with id ${id} not found`,
                    data: null
                });
            }

            return res.status(200).json({
                status: 'OK',
                message: 'Get Beasiswa by id Success',
                data: beasiswa
            });
        } catch (err) {
            next(err);
        }
    },
}