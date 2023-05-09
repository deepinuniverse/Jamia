using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Jamiya
{
    #region Notifications
    public class Notifications
    {
        #region Member Variables
        protected int _id;
        protected string _notes;
        protected unknown _created_dt;
        protected unknown _created_at;
        protected unknown _updated_at;
        #endregion
        #region Constructors
        public Notifications() { }
        public Notifications(string notes, unknown created_dt, unknown created_at, unknown updated_at)
        {
            this._notes=notes;
            this._created_dt=created_dt;
            this._created_at=created_at;
            this._updated_at=updated_at;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string Notes
        {
            get {return _notes;}
            set {_notes=value;}
        }
        public virtual unknown Created_dt
        {
            get {return _created_dt;}
            set {_created_dt=value;}
        }
        public virtual unknown Created_at
        {
            get {return _created_at;}
            set {_created_at=value;}
        }
        public virtual unknown Updated_at
        {
            get {return _updated_at;}
            set {_updated_at=value;}
        }
        #endregion
    }
    #endregion
}