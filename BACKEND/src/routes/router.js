const express = require('express');
const router = express.Router();
const c = require('../controller');
const jwtMiddleware = require('../middleware/jwtMiddleware');

router.post('/register', c.auth.register);
router.post('/login', c.auth.login);

// Route Fakultas
router.get('/fakultas', jwtMiddleware, c.fakultas.index);

// Route Program studi
router.get('/prodi', jwtMiddleware, c.prodi.index);

// Route User
router.get('/users', jwtMiddleware, c.user.index);

module.exports = router;