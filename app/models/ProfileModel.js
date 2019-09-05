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

profileSchema.set('toJSON', {
    versionKey: false
})

profileSchema.options.toJSON.transform = (doc, ret, options) => {
    let idObj = { id: ret._id }
    delete ret._id

    return Object.assign({}, idObj, ret)
}

module.exports = mongoose.model('Profile', profileSchema)
