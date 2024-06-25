const { Periode } = require('../models');
const fakultas = require('../models/fakultas');
const schema = require('../validation');
const Validator = require('fastest-validator');
const v = new Validator;

module.exports = {
    index: async (req, res, next) => {
        try {
            const periode = await Periode.findAll();

            return res.status(200).json({
                status: 'OK',
                message: 'Get All Periode Success',
                data: periode
            });
        } catch (err) {
            next(err);
        }
    },

    create: async (req, res, next) => {
        try {
            const { semester, start_date, end_date } = req.body;
    
            // Convert date strings to Date objects
            const $start_conv = new Date(start_date);
            const $end_conv = new Date(end_date);
    
            // Check if the converted dates are valid
            if (isNaN($start_conv.getTime()) || isNaN($end_conv.getTime())) {
                return res.status(400).json({
                    status: 'BAD REQUEST',
                    message: 'Invalid date format for start_date or end_date',
                    data: null
                });
            }
    
            // Create a new body object with converted dates
            const body = {
                semester,
                start_date: $start_conv,
                end_date: $end_conv
            };
    
            // Perform validation after conversion
            const validate = v.validate(body, schema.periode.create);
            console.log(validate);
    
            if (validate.length) {
                return res.status(400).json(validate);
            }
    
            const created = await Periode.create(body);
    
            return res.status(201).json({
                status: 'CREATED',
                message: 'New Periode Created',
                data: created
            });
        } catch (err) {
            next(err);
        }
    },

    update: async (req, res, next) => {
        try {
            const { id } = req.params;
            let { semester, start_date, end_date } = req.body;
    
            // Convert the date strings to Date objects if provided
            let $start_conv = start_date ? new Date(start_date) : null;
            let $end_conv = end_date ? new Date(end_date) : null;
    
            // Check if the converted dates are valid
            if (($start_conv && isNaN($start_conv.getTime())) || ($end_conv && isNaN($end_conv.getTime()))) {
                return res.status(400).json({
                    status: 'BAD REQUEST',
                    message: 'Invalid date format for start_date or end_date',
                    data: null
                });
            }
    
            // Update the request body with converted dates
            const body = {
                semester,
                start_date: $start_conv,
                end_date: $end_conv
            };
    
            // Validate the updated body
            const validate = v.validate(body, schema.periode.update);
            if (validate.length) {
                return res.status(400).json(validate);
            }
    
            const periode = await Periode.findOne({ where: { id } });
            if (!periode) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Periode doesn't exist`,
                    data: null
                });
            }
    
            // Use existing values if new values are not provided
            semester = semester || periode.semester;
            $start_conv = $start_conv || periode.start_date;
            $end_conv = $end_conv || periode.end_date;
    
            const updated = await Periode.update({
                semester,
                start_date: $start_conv,
                end_date: $end_conv
            }, {
                where: { id }
            });
    
            return res.status(200).json({
                status: 'OK',
                message: 'Update Periode Success',
                data: updated
            });
        } catch (err) {
            next(err);
        }
    },

    delete: async (req, res, next) => {
        try {
            const { id } = req.params;

            const periode = await Periode.findOne({
                where: {
                    id: id
                }
            });

            if (!periode) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Periode Didn't Exist`,
                    data: null
                });
            }

            const deleted = await Periode.destroy({
                where: {
                    id: id
                }
            });

            return res.status(200).json({
                status: 'OK',
                message: 'Delete Periode Success',
                data: deleted
            });
        } catch (err) {
            next(err);
        }
    },

    getById: async (req, res, next) => {
        try {
            const { id } = req.params;

            const periode = await Periode.findOne({
                where: { id },
            });

            if (!periode) {
                return res.status(404).json({
                    status: 'NOT_FOUND',
                    message: `Periode with id ${id} not found`,
                    data: null
                });
            }

            return res.status(200).json({
                status: 'OK',
                message: 'Get Periode by id Success',
                data: periode
            });
        } catch (err) {
            next(err);
        }
    },
}