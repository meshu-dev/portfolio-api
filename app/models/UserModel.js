const mongoose = require('mongoose')

let userSchema = new mongoose.Schema({
        username: {
            type: String,
            required: true,
            minlength: 3,
            maxlength: 50
        },
        password: {
            type: String,
            required: true,
            minlength: 8,
            maxlength: 255
        }
    }, {
        timestamps: true
    }
)

module.exports = mongoose.model('User', userSchema)
