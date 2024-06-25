require('dotenv').config();

const jwt = require('jsonwebtoken');

module.exports = {
    verifyToken: async (req, res, next) => {
        try {
            const token = req.headers.authorization.split(' ')[1]; // Assuming "Bearer token"
            
            if (!token) {
                return res.status(401).json({ error: 'Token not provided' });
            }
            
            // Replace 'your-secret-key' with your actual JWT secret key
            jwt.verify(token, process.env.JWT_SECRET_KEY, (err, decoded) => {
                if (err) {
                    return res.status(401).json({ error: 'Token is invalid' });
                }

                // Optionally, you can pass decoded information back
                res.status(200).json({ message: 'Token is valid', decoded });
            });
        } catch (err) {
            next(err);
        }
    }
};