const { Fakultas, programStudi } = require('../models');
const schema = require('../validation');
const Validator = require('fastest-validator');
const v = new Validator;

module.exports = {
    index: async (req, res, next) => {
        try {
            const prodi = await programStudi.findAll(
                {
                    include: {
                        model:Fakultas,
                        as: 'fakultas'
                    }
                }
            );

            return res.status(200).json({
                status: 'OK',
                message: 'Get All Program Studi Success',
                data: prodi
            });
        } catch (err) {
            next(err);
        }
    },

    create: async (req, res, next) => {
        try {
            const { kode, nama, fakultas_id } = req.body;
            
            const body = req.body;
            const validate = v.validate(body, schema.program_studi.create);
            console.log(validate);
    
            if (validate.length) {
                return res.status(400).json(validate);
            }
    
            const prodi = await programStudi.findOne({ where: { kode } });
    
            if (prodi) {
                return res.status(409).json({
                    status: 'CONFLICT',
                    message: 'Data Already Exist',
                    data: null
                });
            }
    
            const created = await programStudi.create({
                kode,
                nama, 
                fakultas_id: Number(fakultas_id), // Convert role_id to number
            });
    
            return res.status(201).json({
                status: 'CREATED',
                message: 'New Prodi Created',
                data: created
            });
        } catch (err) {
            next(err);
        }
    },

    update: async (req, res, next) => {
        try {
            const { kode } = req.params;
            let { nama, fakultas_id } = req.body;

            const body = req.body;
            const validate = v.validate(body, schema.program_studi.update);

            if (validate.length) {
                return res.status(400).json(validate);
            }

            const prodi = await programStudi.findOne({ where: { kode: kode } });
            if (!prodi) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Program Studi Didn't Exist`,
                    data: null
                })
            }

            if (!nama) nama = prodi.nama;
            if (!fakultas_id) fakultas_id = prodi.fakultas_id;

            const updated = await programStudi.update({
                nama, 
                fakultas_id
            }, {
                where: {
                    kode: kode
                }
            })

            return res.status(200).json({
                status: 'OK',
                message: 'Update Program Studi Success',
                data: updated
            })
        } catch (err) {
            next(err);
        }
    },

    delete: async (req, res, next) => {
        try {
            const { kode } = req.params;

            const prodi =  programStudi.findOne({
                where: {
                    kode: kode
                }
            });

            if (!prodi) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message:  `Program Studi Did'nt Exist`,
                    data: null
                });
            }

            const deleted = await programStudi.destroy({
                where: {
                    kode: kode
                }
            });

            return res.status(200).json({
                status: 'OK',
                message: 'Delete Program Studi Success',
                data: deleted
            });
        } catch (err) {
            next(err);
        }
    },

    getByKode: async (req, res, next) => {
        try {
            const { kode } = req.params;

            const prodi = await programStudi.findOne({
                where: { kode },
            });

            if (!prodi) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Program studi with kode ${kode} not found`,
                    data: null
                });
            }

            return res.status(200).json({
                status: 'OK',
                message: 'Get Program studi by Kode Success',
                data: prodi
            });
        } catch (err) {
            next(err);
        }
    },

}