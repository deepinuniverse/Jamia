using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Jamiya
{
    #region Shareholdersnfamilydata
    public class Shareholdersnfamilydata
    {
        #region Member Variables
        protected int _id;
        protected string _SHR_NO;
        protected string _FCH_SHR_NAME;
        protected string _CIVIL_ID;
        protected string _CODE;
        protected string _CARD_NO;
        #endregion
        #region Constructors
        public Shareholdersnfamilydata() { }
        public Shareholdersnfamilydata(string SHR_NO, string FCH_SHR_NAME, string CIVIL_ID, string CODE, string CARD_NO)
        {
            this._SHR_NO=SHR_NO;
            this._FCH_SHR_NAME=FCH_SHR_NAME;
            this._CIVIL_ID=CIVIL_ID;
            this._CODE=CODE;
            this._CARD_NO=CARD_NO;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string SHR_NO
        {
            get {return _SHR_NO;}
            set {_SHR_NO=value;}
        }
        public virtual string FCH_SHR_NAME
        {
            get {return _FCH_SHR_NAME;}
            set {_FCH_SHR_NAME=value;}
        }
        public virtual string CIVIL_ID
        {
            get {return _CIVIL_ID;}
            set {_CIVIL_ID=value;}
        }
        public virtual string CODE
        {
            get {return _CODE;}
            set {_CODE=value;}
        }
        public virtual string CARD_NO
        {
            get {return _CARD_NO;}
            set {_CARD_NO=value;}
        }
        #endregion
    }
    #endregion
}