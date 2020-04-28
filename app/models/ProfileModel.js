const mongoose = require('mongoose')

let profileSchema = new mongoose.Schema({
        name: {
            type: String,
            unique: false,
            required: true
        },
        introLine1: {
            type: String,
            unique: false,
            required: false
        },
        introLine2: {
            type: String,
            unique: false,
            required: false
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
        }
    }, {
        timestamps: true
    }
)

profileSchema.set('toJSON', {
    versionKey: false
})

profileSchema.options.toJSON.transform = (doc, ret, options) => {
    ret.createdAt = (new Date(ret.createdAt)).toString()
    ret.updatedAt = (new Date(ret.updatedAt)).toString()
    
    let idObj = { id: ret._id }
    delete ret._id

    return Object.assign({}, idObj, ret)
}

module.exports = mongoose.model('Profile', profileSchema)
