// jwtMiddleware.js
const jwt = require('jsonwebtoken');

function jwtMiddleware(req, res, next) {
    // Get token from request header
    const authorizationHeader = req.headers.authorization;

    // Check if authorization header exists
    if (!authorizationHeader) {
        return res.status(401).json({ error: 'No authorization header provided' });
    }

    // Split header to get token
    const [scheme, token] = authorizationHeader.split(' ');

    // Check if token exists and starts with 'Bearer'
    if (!token || scheme !== 'Bearer') {
        return res.status(401).json({ error: 'Invalid authorization header format' });
    }

    // Verify token
    jwt.verify(token, process.env.JWT_SECRET_KEY, (err, decoded) => {
        if (err) {
            return res.status(403).json({ error: 'Failed to authenticate token' });
        }
        // If token is valid, save decoded user information to request object
        req.user = decoded;
        next(); // Proceed to next middleware/route
    });
}

module.exports = jwtMiddleware;