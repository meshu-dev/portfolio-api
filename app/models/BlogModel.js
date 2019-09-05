const mongoose = require('mongoose')

let blogSchema = new mongoose.Schema({
        title: {
            type: String,
            unique: false,
            required: true
        },
        url: {
            type: String,
            unique: false,
            required: true
        },
        thumbUrl: {
            type: String,
            unique: false,
            required: true
        }
    }, {
        timestamps: true
    }
)

module.exports = mongoose.model('Blog', blogSchema)
