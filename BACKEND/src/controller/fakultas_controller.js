const { Fakultas } = require('../models');
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

    // create: async (req, res, next) => {
    //     try {
    //         const { isbn, judul, author_id, pub_id } = req.body;

    //         const body = req.body;
    //         const validate = v.validate(body, schema.book.createBook);

    //         if (validate.length) {
    //             return res.status(400).json(validate);
    //         }

    //         const book = await Book.findOne({ where: { isbn } });

    //         if (book) {
    //             return res.status(409).json({
    //                 status: 'CONFLICT',
    //                 message: 'Data Already Exist',
    //                 data: null
    //             });
    //         }

    //         const created = await Book.create({
    //             isbn,
    //             judul,
    //             author_id,
    //             pub_id
    //         });

    //         return res.status(201).json({
    //             status: 'CREATED',
    //             message: 'New Book Created',
    //             data: created
    //         });
    //     } catch (err) {
    //         next(err);
    //     }
    // },

    // update: async (req, res, next) => {
    //     try {
    //         const { id } = req.params;
    //         let { isbn, judul, author_id, pub_id } = req.body;

    //         const body = req.body;
    //         const validate = v.validate(body, schema.book.updateBook);

    //         if (validate.length) {
    //             return res.status(400).json(validate);
    //         }

    //         const book = await Book.findOne({ where: { id: id } });
    //         if (!book) {
    //             return res.status(404).json({
    //                 status: 'NOT_FOUND',
    //                 message: `Book Didn't Exist`,
    //                 data: null
    //             })
    //         }

    //         if (!isbn) isbn = book.isbn;
    //         if (!judul) judul = book.judul;
    //         if (!author_id) author_id = book.author_id;
    //         if (!pub_id) pub_id = book.pub_id;

    //         const updated = await Book.update({
    //             isbn,
    //             judul,
    //             author_id,
    //             pub_id
    //         }, {
    //             where: {
    //                 id: id
    //             }
    //         })

    //         return res.status(200).json({
    //             status: 'OK',
    //             message: 'Update Book Success',
    //             data: updated
    //         })
    //     } catch (err) {
    //         next(err);
    //     }
    // },

    // delete: async (req, res, next) => {
    //     try {
    //         const { id } = req.params;

    //         const book = await Book.findOne({
    //             where: {
    //                 id: id
    //             }
    //         });

    //         if (!book) {
    //             return res.status(404).json({
    //                 status: 'NOT_FOUND',
    //                 message: `Book Didn't Exist`,
    //                 data: null
    //             });
    //         }

    //         const deleted = await Book.destroy({
    //             where: {
    //                 id: id
    //             }
    //         });

    //         return res.status(200).json({
    //             status: 'OK',
    //             message: 'Delete Book Success',
    //             data: deleted
    //         });
    //     } catch (err) {
    //         next(err);
    //     }
    // }
}