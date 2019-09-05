const mongoose = require('mongoose')

let projectSchema = new mongoose.Schema({
        title: {
            type: String,
            unique: false,
            required: true
        },
        description: {
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

module.exports = mongoose.model('Project', projectSchema)
