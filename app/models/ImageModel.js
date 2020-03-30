const mongoose = require('mongoose')

let Schema = mongoose.Schema

let imageSchema = new Schema({
        filename: {
            type: String,
            unique: false,
            required: true
        },
        url: {
            type: String,
            unique: true,
            required: true
        }
    }, {
        timestamps: true
    }
)

imageSchema.set('toJSON', {
    versionKey: false
})

imageSchema.options.toJSON.transform = (doc, ret, options) => {
    ret.createdAt = (new Date(ret.createdAt)).toString()
    ret.updatedAt = (new Date(ret.updatedAt)).toString()
    
    let idObj = { id: ret._id }
    delete ret._id
    
    return Object.assign({}, idObj, ret)
}

module.exports = mongoose.model('Image', imageSchema)
