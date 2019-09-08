const jwt = require('jsonwebtoken')

exports.verify = (req, res, next) => {
    if (req.method === 'GET' || req.url === '/users/login') {
        return next()
    }

    /*
    if (process.env.APP_ENV === 'dev') {
        return next()
    } */

    let token = req.headers['authorization']

    if (token === undefined) {
        return res.status(401)
                  .json({
                    message: 'Access denied! Auth token is required'
                  })
    }

    try {
        token = token.replace('Bearer', '')
        token = token.trim()

        const data = jwt.verify(token, process.env.JWT_PRIVATE_KEY)
        req.user = data

        next()
    } catch (err) {
        let errMsg = 'An error occured! Please try again later',
            statusCode = 500

        if (err.name === 'TokenExpiredError') {
            errMsg = 'Authentication required';
            statusCode = 401
        }
        return res.status(statusCode)
                  .json({
                    message: errMsg
                  })
    }
}
