CRC8      START 0

. MAIN FLOW
FIRST     JSUB INIT
          JSUB READIN
          JSUB COPYBUF
          JSUB CRCCALC
          JSUB APPENDCRC
          JSUB EMITBUF
MAIN_DONE J    MAIN_DONE

. INIT CRC
INIT      LDA  #0
          STA  R
          LDA  #M_BUF
          STA  IN_PTR
          LDA  #MR_BUF
          STA  OUT_PTR
          RSUB

. READ: length + message
READIN    LDA  #0
READ_LEN  TD   INDEV
          JEQ  READ_LEN
          RD   INDEV
          STA  MSG_LEN
          LDA  MSG_LEN
          COMP #0
          JEQ READ_DONE
          LDX  #0
READ_LOOP TD   INDEV
          JEQ  READ_LOOP
          RD   INDEV
          STCH M_BUF,X
          TIX  MSG_LEN
          JLT  READ_LOOP
READ_DONE RSUB

. COPY M_BUF → MR_BUF
COPYBUF   LDA  MSG_LEN
          COMP #0
          JEQ  COPY_DONE
          LDX  #0
COPY_LOOP LDCH M_BUF,X
          STCH MR_BUF,X
          TIX  MSG_LEN
          JLT  COPY_LOOP
COPY_DONE RSUB

. CRC-8 core
CRCCALC   LDA  #0
          STA  R
          LDX  #0
          LDA  MSG_LEN
          COMP #0
          JEQ  CRC_DONE

BYTE_LOOP LDA  #0
          LDCH MR_BUF,X
          STA  BYTEVAL

          LDA  R
          OR   BYTEVAL
          STA  XOR_OR
          LDA  R
          AND  BYTEVAL
          STA  XOR_AND
          LDA  XOR_OR
          SUB  XOR_AND
          STA  R

          LDA  #8
          STA  BITCTR

BIT_LOOP  LDA  R
          AND  MASK_MSB
          COMP #0
          JEQ  SHIFT_ONLY

          LDA  R
          SHIFTL A,1
          AND  BYTE_MASK
          STA  R

          LDA  R
          OR   POLY
          STA  XOR_OR
          LDA  R
          AND  POLY
          STA  XOR_AND
          LDA  XOR_OR
          SUB  XOR_AND
          AND  BYTE_MASK
          STA  R
          J    NEXT_BIT

SHIFT_ONLY LDA  R
          SHIFTL A,1
          AND  BYTE_MASK
          STA  R

NEXT_BIT  LDA  BITCTR
          SUB  #1
          STA  BITCTR
          COMP #0
          JGT  BIT_LOOP

          TIX  MSG_LEN
          JLT  BYTE_LOOP
CRC_DONE  RSUB

. append CRC
APPENDCRC LDA  R
          AND  BYTE_MASK
          LDX  MSG_LEN
          STCH MR_BUF,X
          RSUB

. output buffer
EMITBUF   LDA  MSG_LEN
          ADD  #1
          STA  OUTLEN
          LDX  #0
EMIT_WAIT TD   OUTDEV
          JEQ  EMIT_WAIT
          LDCH MR_BUF,X
          WD   OUTDEV
          TIX  OUTLEN
          JLT  EMIT_WAIT
          RSUB

POLY      WORD 7
MASK_MSB  WORD 128
BYTE_MASK WORD 255
INDEV     BYTE X'F1'
OUTDEV    BYTE X'05'

R         WORD 0
IN_PTR    WORD 0
OUT_PTR   WORD 0
MSG_LEN   WORD 0
OUTLEN    WORD 0
BYTEVAL   WORD 0
XOR_OR    WORD 0
XOR_AND   WORD 0
BITCTR    WORD 0

BUF_MAX     EQU 256
MR_BUF_SIZE EQU 257

M_BUF   RESB BUF_MAX
MR_BUF  RESB MR_BUF_SIZE

          END  FIRST