const express = require('express');
const router = express.Router();
const c = require('../controller');
const jwtMiddleware = require('../middleware/jwtMiddleware');

router.post('/login', c.auth.login);
router.post('/verify-token', c.verifyToken.verifyToken);

// Route Fakultas
router.get('/fakultas', jwtMiddleware, c.fakultas.index);
router.get('/fakultas/:kode', jwtMiddleware, c.fakultas.getByKode);
router.post('/fakultas/create', jwtMiddleware, c.fakultas.create);
router.put('/fakultas/:kode', jwtMiddleware, c.fakultas.update);
router.delete('/fakultas/:kode', jwtMiddleware, c.fakultas.delete);

// Route Program studi
router.get('/prodi', jwtMiddleware, c.prodi.index);
router.get('/prodi/:kode', jwtMiddleware, c.prodi.getByKode);
router.post('/prodi/create', jwtMiddleware, c.prodi.create);
router.put('/prodi/:kode', jwtMiddleware, c.prodi.update);
router.delete('/prodi/:kode', jwtMiddleware, c.prodi.delete);

// Route Role
router.get('/role', jwtMiddleware, c.role.index);
router.get('/role/:id', jwtMiddleware, c.role.getById);
router.post('/role/create', jwtMiddleware, c.role.create);
router.put('/role/:id', jwtMiddleware, c.role.update);
router.delete('/role/:id', jwtMiddleware, c.role.delete);

// Route User
router.get('/users', jwtMiddleware, c.user.index);
router.get('/users/:nrp', jwtMiddleware, c.user.getByNrp);
router.post('/users/create', jwtMiddleware, c.user.create);
router.put('/users/:nrp', jwtMiddleware, c.user.update);
router.delete('/users/:nrp', jwtMiddleware, c.user.delete);

router.get('/periode', jwtMiddleware, c.periode.index);
router.get('/periode/:id', jwtMiddleware, c.periode.getById);
router.post('/periode/create', jwtMiddleware, c.periode.create);
router.put('/periode/:id', jwtMiddleware, c.periode.update);
router.delete('/periode/:id', jwtMiddleware, c.periode.delete);

router.get('/beasiswa', jwtMiddleware, c.beasiswa.index);
router.get('/beasiswa/:id', jwtMiddleware, c.beasiswa.getById);
router.post('/beasiswa/create', jwtMiddleware, c.beasiswa.create);
router.put('/beasiswa/:id', jwtMiddleware, c.beasiswa.update);
router.delete('/beasiswa/:id', jwtMiddleware, c.beasiswa.delete);

module.exports = router;