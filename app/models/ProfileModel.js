const mongoose = require('mongoose')

let profileSchema = new mongoose.Schema({
        name: {
            type: String,
            unique: false,
            required: true
        },
        jobTitle: {
            type: String,
            unique: false,
            required: true
        },
        bio: {
            type: String,
            unique: false,
            required: true
        },
        githubUrl: {
            type: String,
            unique: false,
            required: false
        },
        linkedInUrl: {
            type: String,
            unique: false,
            required: false
        },
        email: {
            type: String,
            unique: false,
            required: false
        },
        cvUrl: {
            type: String,
            unique: false,
            required: false
        }
    }, {
        timestamps: true
    }
)

module.exports = mongoose.model('Profile', profileSchema)
