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

userSchema.set('toJSON', {
    versionKey: false
})

userSchema.options.toJSON.transform = (doc, ret, options) => {
    ret.createdAt = (new Date(ret.createdAt)).toString()
    ret.updatedAt = (new Date(ret.updatedAt)).toString()
    
    let idObj = { id: ret._id }
    delete ret._id

    return Object.assign({}, idObj, ret)
}

module.exports = mongoose.model('User', userSchema)
